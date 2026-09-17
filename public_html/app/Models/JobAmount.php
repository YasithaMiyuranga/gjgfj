<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Class JobAmount
 *
 * @property int $id
 * @property int $emp_id
 * @property string $name
 * @property int $order_id
 * @property Carbon $booking_date
 * @property float $job_amount
 * @property Carbon|null $payment_date
 * @property string $payment_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class JobAmount extends Model
{
    protected $fillable = [
        'emp_id',
        'name',
        'event_id',
        'order_id',
        'booking_date',
        'job_amount',
        'payment_status',
        'payment_date',
    ];

    protected $dates = [
        'booking_date',
        'payment_date',
    ];

    protected $table = 'job_amount'; // Specify the table name if it's different from the class name

    protected $primaryKey = 'id'; // Specify the primary key field if it's different from 'id'

    public $incrementing = true; // Set to false if the primary key is not auto-incrementing

    // Optionally, you can define relationships, accessors, mutators, etc. here

    public function employes()
    {
        return $this->belongsTo(Employe::class, 'emp_id');
    }

    /**
     * Updates, creates, or deletes job amount records for a specific order.
     *
     * This function performs the following operations:
     * - Updates existing JobAmount records based on the provided data array.
     * - Creates new JobAmount records if they do not exist.
     * - Deletes JobAmount records that are not present in the provided data array.
     * - Updates the corresponding order's name field with a comma-separated list of employee names.
     *
     * @param array $data An array of data containing job amounts, employee names, and payment statuses.
     * @param int $order_id The ID of the order for which job amounts should be updated.
     * @return void Redirects back with an error message in case of an exception.
     */
    public static function updateCreateOrDelete(Array $data, $order_id, $event_id)
    {
        try {
            $order = Order::find($order_id);
            // Add emp_id to the data
            foreach ($data as $key => $value) {
                $data[$key]['emp_id'] = Employe::where('name', $value['name'])->first()->emp_id;
            }

            foreach ($data as $key => $value) {

                // Get emp_id
                $emp_id = $value['emp_id'];
                $name = $value['name'];
                $order_id = $order->order_id;
                $event_id = $event_id;
                $booking_date = $order->booking_date;
                $job_amount = $value['job_amount'];
                $payment_status = ($value['payment_status'] == "Not paid") ? 'Pending' : $value['payment_status'];
                $payment_date = null;

                $jobAmount = JobAmount::where('emp_id', $emp_id)
                    ->where('name', $name)
                    ->where('order_id', $order_id)
                    ->where('booking_date', $booking_date)
                    ->first();

                if ($jobAmount) {
                    $jobAmount->job_amount = $job_amount;
                    $jobAmount->payment_status = $payment_status;
                    $jobAmount->event_id = $event_id;
                    $jobAmount->save();
                } else {
                    JobAmount::create([
                        'emp_id' => $emp_id,
                        'name' => $name,
                        'event_id' => $event_id,
                        'order_id' => $order_id,
                        'booking_date' => $booking_date,
                        'job_amount' => $job_amount,
                        'payment_status' => $payment_status,
                    ]);
                }

            }

            // Get emp name array
            $empNames = array_column($data, 'name');

            // Delete name column data in order table
            $order->name = implode(',', $empNames);
            $order->save();


            // Delete records that are not in the $data array using whereNotIn and emp_id
            JobAmount::whereNotIn('emp_id', array_column($data, 'emp_id'))->WHERE('order_id', $order_id)->delete();

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating or deleting records: ' . $e->getMessage());
        }
    }
}
