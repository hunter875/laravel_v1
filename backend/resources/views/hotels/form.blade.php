<div class="form-group">
    <label for="hotel_name">Hotel Name</label>
    <input type="text" class="form-control" name="hotel_name" id="hotel_name" value="{{ old('hotel_name', $hotel->hotel_name ?? '') }}" required>
</div>

<div class="form-group">
    <label for="hotel_code">Hotel Code</label>
    <input type="text" class="form-control" name="hotel_code" id="hotel_code" value="{{ old('hotel_code', $hotel->hotel_code ?? '') }}">
<div class="form-group">
    <label for="address1">Address 1</label>
    <input type="text" class="form-control" name="address1" id="address1" value="{{ old('address1', $hotel->address1 ?? '') }}" >
</div>
<div class="form-group">
    <label for="address2">Address 2</label>
    <input type="text" class="form-control" name="address2" id="address2" value="{{ old('address2', $hotel->address2 ?? '') }}">
</div>
<div class="form-group">
    <label for="city_id">City</label>
    <select class="form-control" name="city_id" id="city_id" required>
        @foreach ($cities as $city)
            <option value="{{ $city->id }}" {{ (old('city_id') ?? $hotel->city_id ?? '') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="telephone">Telephone</label>
    <input type="text" class="form-control" name="telephone" id="telephone" value="{{ old('telephone', $hotel->telephone ?? '') }}" required>
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $hotel->email ?? '') }}" required>
</div>
<div class="form-group">
    <label for="FAX">FAX</label>
    <input type="text" class="form-control" name="FAX" id="FAX" value="{{ old('fax', $hotel->fax ?? '') }}">
</div>
<div class="form-group">
    <label for="company_name">Company Name</label>
    <input type="text" class="form-control" name="company_name" id="company_name" value="{{ old('company_name', $hotel->company_name ?? '') }}">
</div>
<div class="form-group">
    <label for="tax_code">Tax Code</label>
    <input type="text" class="form-control" name="tax_code" id="tax_code" value="{{ old('tax_code', $hotel->tax_code ?? '') }}">
</div>
