@unless ($isCurrentLanguage)
    <small>(
@endunless
{{ $value }}
@unless ($isCurrentLanguage)
    )</small>
@endunless
