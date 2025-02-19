<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\HotelRepositoryInterface;
use App\Models\City;
use App\Models\User;
use App\Models\Hotel;
use App\Http\Requests\HotelRequest;
use Illuminate\Http\RedirectResponse;

class HotelController extends Controller
{
    protected $hotelRepository;

    public function __construct(HotelRepositoryInterface $hotelRepository)
    {
        $this->middleware('auth');
        $this->hotelRepository = $hotelRepository;
    }

    private function getCitiesAndUsers(): array
    {
        return [
            'cities' => City::all(),
            'users'  => User::all(),
        ];
    }

    private function getHotelForAction(int $id, string $action = 'access'): Hotel|RedirectResponse
    {
        $hotel = $this->hotelRepository->find($id);

        if (!$hotel) {
            return redirect()->route('hotels.index')
                ->with('error', 'Unable to find the hotel.');
        }

        if (auth()->user()->role_id !== 1 && $hotel->user_id !== auth()->id()) {
            return redirect()->route('hotels.index')
                ->with('error', "You do not have permission to {$action} this hotel.");
        }

        return $hotel;
    }

    public function index(Request $request)
    {
        $query = Hotel::query();

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }
        if ($request->filled('hotel_name')) {
            $query->where('hotel_name', 'LIKE', "%{$request->hotel_name}%");
        }
        if ($request->filled('hotel_code')) {
            $query->where('hotel_code', 'LIKE', "%{$request->hotel_code}%");
        }

        if (auth()->user()->role_id !== 1) {
            $query->where('user_id', auth()->id());
        }

        $hotels = $query->paginate(10);
        $cities = City::all();

        return view('hotels.index', compact('hotels', 'cities'));
    }

    public function search(Request $request)
    {
        $filters = $request->only(['city_id', 'hotel_code', 'hotel_name']);

        if (auth()->user()->role_id !== 1) {
            $filters['user_id'] = auth()->id();
        }

        $hotels = $this->hotelRepository->searchHotels($filters);
        $cities = City::all();

        return view('hotels.index', compact('hotels', 'cities'));
    }

    public function create()
    {
        return view('hotels.create', $this->getCitiesAndUsers());
    }

    public function store(HotelRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        Hotel::create($data);

        return redirect()->route('hotels.index')
            ->with('success', 'Hotel created successfully.');
    }

    public function edit(int $id)
    {
        $hotel = $this->getHotelForAction($id, 'edit');
        if ($hotel instanceof RedirectResponse) {
            return $hotel;
        }

        return view('hotels.edit', array_merge(['hotel' => $hotel], $this->getCitiesAndUsers()));
    }

    public function update(HotelRequest $request, int $id)
    {
        $hotel = $this->getHotelForAction($id, 'update');
        if ($hotel instanceof RedirectResponse) {
            return $hotel;
        }

        $data = $request->validated();
        $this->hotelRepository->update($id, $data);

        return redirect()->route('hotels.index')
            ->with('success', 'Hotel updated successfully.');
    }

    public function show(int $id)
    {
        $hotel = $this->getHotelForAction($id, 'view');
        if ($hotel instanceof RedirectResponse) {
            return $hotel;
        }

        return view('hotels.show', compact('hotel'));
    }

    public function destroy(int $id)
    {
        $hotel = $this->getHotelForAction($id, 'delete');
        if ($hotel instanceof RedirectResponse) {
            return $hotel;
        }

        $hotel->delete();

        return redirect()->route('hotels.index')
            ->with('success', 'Hotel deleted successfully.');
    }
}
