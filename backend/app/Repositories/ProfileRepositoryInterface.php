<?php
namespace App\Repositories;

interface ProfileRepositoryInterface
{
    public function getProfile($user);
    public function update($id, array $data);
    public function deleteProfile($userId);
}