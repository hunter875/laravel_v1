<?php

namespace App\Repositories;

interface HotelRepositoryInterface
{
    public function paginate($perPage, $relations = []);
    public function create(array $data);
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
    public function searchHotels(array $filters);
    public function getHotelsByUser($userId, $perPage);
}
