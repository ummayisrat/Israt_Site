@php($entry = $entry ?? null)

<label for="title">Title</label>
<input type="text" id="title" name="title" value="{{ old('title', $entry?->title) }}" required>
@error('title') <div class="field-error">{{ $message }}</div> @enderror

<label for="category">Category</label>
<input type="text" id="category" name="category" value="{{ old('category', $entry?->category ?? 'Journal Entry') }}" required>
@error('category') <div class="field-error">{{ $message }}</div> @enderror

<label for="entry_date">Date</label>
<input type="date" id="entry_date" name="entry_date" value="{{ old('entry_date', ($entry?->entry_date ?? now())->format('Y-m-d')) }}" required>
@error('entry_date') <div class="field-error">{{ $message }}</div> @enderror

<label for="image_url">Image URL (optional)</label>
<input type="url" id="image_url" name="image_url" value="{{ old('image_url', $entry?->image_url) }}" placeholder="https://...">
@error('image_url') <div class="field-error">{{ $message }}</div> @enderror

<label for="body">Entry</label>
<textarea id="body" name="body" required>{{ old('body', $entry?->body) }}</textarea>
@error('body') <div class="field-error">{{ $message }}</div> @enderror
