<p>{{ ($case->province->name ?? null) . ',' . ($case->regency->name ?? null) . ',' . ($case->district->name ?? null) }}
</p>
<small class="text-gray">{{ $case->latitude . ',' . $case->longitude }}</small>
