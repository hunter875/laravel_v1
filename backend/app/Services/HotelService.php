<?php
namespace App\Services;

use App\Repositories\HotelRepositoryInterface;
use App\Common\Constant;
use App\Models\Hotel;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Auth;

class HotelService {
    protected $hotelRepository;

    public function __construct(HotelRepositoryInterface $hotelRepository)
    {
        $this->hotelRepository = $hotelRepository;
    }

    public function getAllHotels()
    {
        return Hotel::paginate(Constant::PAGINATE_DEFAULT);
    }

    public function getHotelById($id)
    {
        return Hotel::find($id);
    }

    public function create(array $data)
    {
        if (Auth::user()->role !== 'admin') {
            throw new CustomException('Unauthorized', 403);
        }

        try {
            return $this->hotelRepository->create($data);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['error' => 'Hotel creation failed'], 500);
        }
    }

    public function getHome(){
        return $url = '/home';
    }

    public function update($id, array $data)
    {
        if (Auth::user()->role !== 'admin') {
            throw new CustomException('Unauthorized', 403);
        }

        $hotel = Hotel::find($id);
        if (!$hotel) {
            return null;
        }
        $hotel->update($data);
        return $hotel;
    }

    public function delete($id)
    {
        if (Auth::user()->role !== 'admin') {
            throw new CustomException('Unauthorized', 403);
        }

        $hotel = Hotel::find($id);
        if (!$hotel) {
            return null;
        }
        $hotel->delete();
        return $hotel;
    }

    public function searchHotels(array $filters)
    {
        return $this->hotelRepository->searchHotels($filters);
    }
}