<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Phpml\Regression\LeastSquares;

class EquipmentInvestmentController extends Controller
{
    /**
     * Show the equipment investment analysis page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        return view('Equipment.investmentAnalysis' , compact('items'));
    }
    /**
     * Calculate the predicted ROI percentage and accuracy based on given input data.
     * Uses a 2nd-degree polynomial Least Squares regression model trained on the equipment_roi_data.csv file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function calculateROI(Request $request)
    {
        // Validate input
        $request->validate([
            'equipment_id' => 'required|integer|exists:item,item_id',
            'initial_cost' => 'required|numeric|gt:0',
            'maintenance_cost' => 'required|numeric|min:0',
            'expected_revenue' => 'required|numeric|gt:0',
        ]);

        // Load CSV data
        $csvPath = storage_path('app/public/equipment_roi_data.csv');

        if (!file_exists($csvPath)) {
            return response()->json(['error' => 'Training data CSV not found.'], 500);
        }

        $samples = [];
        $targets = [];

        if (($handle = fopen($csvPath, 'r')) !== false) {
            fgetcsv($handle); // skip header row
            while (($row = fgetcsv($handle, 1000, ",")) !== false) {
                // Assuming CSV columns: initial_cost, maintenance_cost, expected_revenue, roi
                $samples[] = [
                    (float) $row[0], // initial_cost
                    (float) $row[1], // maintenance_cost
                    (float) $row[2], // expected_revenue
                ];
                $targets[] = (float) $row[3]; // ROI = ((revenue - maintenance) / initial) * 100
            }
            fclose($handle);
        }

        // Split into training and test data
        $trainSize = (int) (count($samples) * 0.8);
        $trainSamples = array_slice($samples, 0, $trainSize);
        $trainTargets = array_slice($targets, 0, $trainSize);
        $testSamples = array_slice($samples, $trainSize);
        $testTargets = array_slice($targets, $trainSize);

        // Train model
        $regression = new LeastSquares(2);
        $regression->train($trainSamples, $trainTargets);

        // Accuracy calculation (MAPE)
        $predictions = array_map(fn($sample) => $regression->predict($sample), $testSamples);
        $mape = 0;
        $count = count($testTargets);
        for ($i = 0; $i < $count; $i++) {
            $mape += abs($testTargets[$i] - $predictions[$i]) / max($testTargets[$i], 1);
        }
        $accuracy = round((1 - ($mape / $count)) * 100, 2);

        // Predict new ROI from user input
        $userSample = [
            $request->input('initial_cost'),
            $request->input('maintenance_cost'),
            $request->input('expected_revenue'),
        ];
        $predictedROI = $regression->predict($userSample);

        return response()->json([
            'predicted_roi_percent' => round($predictedROI, 2),
            'accuracy_percent' => $accuracy
        ]);
    }

}
