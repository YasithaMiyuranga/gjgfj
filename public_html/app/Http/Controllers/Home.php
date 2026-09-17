<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Album;
use App\Models\Agenda;
use App\Models\SoldOutSeats;
use App\Models\Ticket;
use App\Models\Package;
use App\Models\AdminEvent;
use App\Models\AlbumImage;
use App\Models\PackageItem;
use App\Models\EventCustomerCare;
use App\Models\PackageCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Log;

class Home extends Controller
{

    function Home()
    {
        $bannerName = "Lion Events & Entertainment";
        $bannerImage = "images/banner.jpg";
        $bannerarr = [
            'workcount' => 100,
            'title' => $bannerName,
            'image' => $bannerImage
        ];
        $packages = Package::all();
        return view('User.index', compact('bannerarr', 'packages'));
    }
    function packages()
    {
        $packages = Package::where('status', 'active')->get();
        return view('User.packages', ['packages' => $packages]);
    }
    function singlepackage($package_id)
    {
        $package = Package::find($package_id);
        $packageItems = PackageItem::where('package_id', $package_id)->get();
        foreach ($packageItems as $packageItem) {
            $item = DB::table('item')->where('item_id', $packageItem->item_id)->first();
            $packageItem->item_name = $item->item_name;
            $packageItem->item_image = $item->image;
            $packageItem->item_price = $item->rent_price;
            $packageItem->item_description = $item->description;
            $packageItem->item_category = $item->category;
            $packageItem->item_status = $item->status;
            $packageItem->item_stock = $item->in_stock;
        }
        return view('User.single-package', compact('package', 'packageItems'));
    }
    function singleitem($item_id)
    {
        $item = Item::find($item_id);
        return view('User.single-item', ['item' => $item]);
    }
    function events()
    {

        $events = AdminEvent::where('is_public', '1')->where('event_date', '>=', date('Y-m-d'))->orderBy('event_date', 'asc')->get();

        return view('User.events', compact('events'));
    }
    function single_event(AdminEvent $event)
    {
        // Get Tickets Details
        $ticketDetails = Ticket::where('eid', '=', $event->eid)->get();

        // Get a specific event details with sponsors
        $event = AdminEvent::where('eid', '=', $event->eid)->with('sponsors', 'agendas', 'artists')->first();

        // Get agenda agenda details
        $event->agendas->load('agendaDetails');
        foreach ($ticketDetails as $ticket) {
            $soldOutSeats = SoldOutSeats::where('ticket_id', $ticket->id)->pluck('seat_number')->toArray();
            $ticket->sold_out_seats = $soldOutSeats;
        }
        // Get event customer care details
        $customerCare = EventCustomerCare::where('event_id', $event->eid)->first();

        return view('User.single_event', compact('event', 'ticketDetails', 'customerCare'));

    }
    function about()
    {
        return view('User.about');
    }
    function contactus()
    {
        return view('User.contactus');
    }
    function blog()
    {
        return view('User.blog');
    }
    function gallery()
    {
        $viewgallery = Album::orderByDesc('id')->get(); //get descending order
        return view('User.gallery', compact('viewgallery'));
    }
    function single_gallery($id)
    {
        // $viewgallery =  Album::find($id);
        // return view('User.single_gallery', compact('viewgallery'));
        $album = Album::findOrFail($id);
        $albumImages = AlbumImage::with('meta')
            ->where('album_id', $id)
            ->where('status', 'active')
            ->get();
        return view('User.single_gallery', compact('album', 'albumImages'));
    }

    function cp_item_view()
    {
        $items = Item::where('visible_to_customer', 'Yes')->get();
        return view('Custom_Packages.items_view', compact('items'));

    }

    function cp_single_item_view($id)
    {
        $item = Item::find($id);
        return view('Custom_Packages.single_item_view', ['item' => $item]);
    }

    function privacy()
    {
        return view('User.privacy-policy');
    }

    function terms()
    {
        return view('User.terms-condition');
    }
}
