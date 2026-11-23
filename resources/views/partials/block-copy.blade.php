@foreach (preg_split("/\r?\n\s*\r?\n/", trim((string) $body)) as $chunk)
    @if ($chunk !== '')
        <p @class(['output' => str_starts_with($chunk, 'Output:')])>{{ $chunk }}</p>
    @endif
@endforeach
