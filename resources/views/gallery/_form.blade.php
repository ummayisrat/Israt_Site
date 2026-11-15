@php($item = $item ?? null)

<label for="title">Title</label>
<input type="text" id="title" name="title" value="{{ old('title', $item?->title) }}" required>
@error('title') <div class="field-error">{{ $message }}</div> @enderror

<label for="category">Category</label>
<input type="text" id="category" name="category" value="{{ old('category', $item?->category) }}" placeholder="Nature, Travel, ..." required>
@error('category') <div class="field-error">{{ $message }}</div> @enderror

<label for="image_url">Image URL</label>
<input type="url" id="image_url" name="image_url" value="{{ old('image_url', $item?->image_url) }}" placeholder="https://..." required>
@error('image_url') <div class="field-error">{{ $message }}</div> @enderror

<label for="image_alt">Image description (optional)</label>
<input type="text" id="image_alt" name="image_alt" value="{{ old('image_alt', $item?->image_alt) }}">
@error('image_alt') <div class="field-error">{{ $message }}</div> @enderror
