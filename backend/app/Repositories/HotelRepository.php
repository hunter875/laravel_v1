<?php

namespace App\Repositories;

use App\Models\Hotel;

class HotelRepository implements HotelRepositoryInterface
{
    protected $model;

    public function __construct(Hotel $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function paginate($perPage = 10, $relations = [])
    {
        return $this->model->with($relations)->paginate($perPage);
    }

    public function with($relations)
    {
        return $this->model->with($relations);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $hotel = $this->model->find($id);
        if ($hotel) {
            $hotel->update($data);
            return $hotel;
        }
        return null;
    }

    public function delete($id)
    {
        $hotel = $this->model->find($id);
        if ($hotel) {
            $hotel->delete(); // Soft delete
            return $hotel;
        }
        return null;
    }

    public function searchHotels(array $filters)
    {
        $query = $this->model->query()->with('city');
        if (!empty($filters['cityId'])) {
            $query->where('city_id', $filters['cityId']);
        }
        if (!empty($filters['hotelCode'])) {
            $query->where('hotel_code', 'LIKE', "%{$filters['hotelCode']}%");
        }
        if (!empty($filters['hotelName'])) {
            $query->where('hotel_name', 'LIKE', "%{$filters['hotelName']}%");
        }
        if (!empty($filters['userId'])) {
            $query->where('user_id', $filters['userId']);
        }
        return $query->paginate(10);
    }

    public function getHotelsByUser($userId, $perPage = 10)
    {
        return $this->model->where('user_id', $userId)->paginate($perPage);
    }
}
