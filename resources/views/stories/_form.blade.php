@php($story = $story ?? null)

<label for="title">Title</label>
<input type="text" id="title" name="title" value="{{ old('title', $story?->title) }}" required>
@error('title') <div class="field-error">{{ $message }}</div> @enderror

<label for="image_url">Image URL</label>
<input type="url" id="image_url" name="image_url" value="{{ old('image_url', $story?->image_url) }}" placeholder="https://..." required>
@error('image_url') <div class="field-error">{{ $message }}</div> @enderror

<label for="image_alt">Image description (optional)</label>
<input type="text" id="image_alt" name="image_alt" value="{{ old('image_alt', $story?->image_alt) }}">
@error('image_alt') <div class="field-error">{{ $message }}</div> @enderror

<label for="body">Story</label>
<textarea id="body" name="body" required>{{ old('body', $story?->body) }}</textarea>
@error('body') <div class="field-error">{{ $message }}</div> @enderror
