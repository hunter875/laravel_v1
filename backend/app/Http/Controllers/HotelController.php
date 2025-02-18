<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\HotelRepositoryInterface;
use App\Models\City;
use App\Models\User;
use App\Models\Hotel;
use App\Http\Requests\HotelRequest;

class HotelController extends Controller
{
    protected $hotelRepository;

    public function __construct(HotelRepositoryInterface $hotelRepository)
    {
        $this->hotelRepository = $hotelRepository;
        $this->middleware('auth'); // Bắt buộc đăng nhập mới truy cập được
    }

    /**
     * Lấy danh sách thành phố & người dùng (tối ưu để tránh truy vấn lặp lại).
     */
    private function getCitiesAndUsers()
    {
        return [
            'cities' => City::all(),
            'users' => User::all()
        ];
    }

    /**
     * Hiển thị danh sách khách sạn.
     */
    public function index(Request $request)
    {
        $query = Hotel::query();

        if ($request->has('city_id') && $request->city_id) {
            $query->where('city_id', $request->city_id);
        }

        if ($request->has('hotel_name') && $request->hotel_name) {
            $query->where('hotel_name', 'LIKE', "%{$request->hotel_name}%");
        }

        if ($request->has('hotel_code') && $request->hotel_code) {
            $query->where('hotel_code', 'LIKE', "%{$request->hotel_code}%");
        }

        $hotels = $query->paginate(10);
        $cities = City::all();

        return view('hotels.index', compact('hotels', 'cities'));
    }

    /**
     * Tìm kiếm khách sạn theo bộ lọc.
     */
    public function search(Request $request)
    {
        $filters = $request->only(['city_id', 'hotel_code', 'hotel_name']);
        $hotels = $this->hotelRepository->searchHotels($filters);

        return view('hotels.index', [
            'hotels' => $hotels,
            'cities' => City::all()
        ]);
    }

    /**
     * Hiển thị trang tạo khách sạn.
     */
    public function create()
    {
        return view('hotels.create', $this->getCitiesAndUsers());
    }

    /**
     * Lưu khách sạn mới vào database.
     */
    public function store(HotelRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id; // Lưu ID người dùng đăng nhập

        Hotel::create($data);

        return redirect()->route('hotels.index')->with('success', 'Khách sạn được tạo thành công.');
    }

    /**
     * Hiển thị trang chỉnh sửa khách sạn.
     */
    public function edit($id)
    {
        $hotel = $this->hotelRepository->find($id);

        if (!$hotel) {
            return redirect()->route('hotels.index')->with('error', 'Không tìm thấy khách sạn.');
        }

        return view('hotels.edit', array_merge(['hotel' => $hotel], $this->getCitiesAndUsers()));
    }

    /**
     * Cập nhật thông tin khách sạn.
     */
    public function update(HotelRequest $request, $id)
    {
        $hotel = $this->hotelRepository->find($id);

        if (!$hotel) {
            return redirect()->route('hotels.index')->with('error', 'Không tìm thấy khách sạn.');
        }

        // Nếu không phải admin, chỉ cho phép cập nhật khách sạn của mình
        if (auth()->user()->role_id != 1 && $hotel->user_id != auth()->id()) {
            return redirect()->route('hotels.index')->with('error', 'Bạn không có quyền chỉnh sửa khách sạn này.');
        }

        $data = $request->validated();
        $this->hotelRepository->update($id, $data);

        return redirect()->route('hotels.index')->with('success', 'Khách sạn được cập nhật thành công.');
    }

    /**
     * Hiển thị chi tiết khách sạn.
     */
    public function show($id)
    {
        $hotel = $this->hotelRepository->find($id);

        if (!$hotel) {
            return redirect()->route('hotels.index')->with('error', 'Không tìm thấy khách sạn.');
        }

        return view('hotels.show', compact('hotel'));
    }

    /**
     * Xóa khách sạn.
     */
    public function destroy($id)
    {
        $hotel = $this->hotelRepository->find($id);

        if (!$hotel) {
            return redirect()->route('hotels.index')->with('error', 'Không tìm thấy khách sạn.');
        }

        // Nếu không phải admin, chỉ cho phép xóa khách sạn của mình
        if (auth()->user()->role_id != 1 && $hotel->user_id != auth()->id()) {
            return redirect()->route('hotels.index')->with('error', 'Bạn không có quyền xóa khách sạn này.');
        }

        $hotel->delete();
        return redirect()->route('hotels.index')->with('success', 'Khách sạn đã được xóa.');
    }
}
