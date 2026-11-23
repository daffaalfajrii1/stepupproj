@php
    $mark = \App\Support\Media::url($site['logo'] ?? null);
@endphp
@if ($members->isNotEmpty())
    @php $mid = ($members->count() - 1) / 2; @endphp
    <div class="lanyard" aria-label="Kartu tim">
        <div class="lanyard-stage">
            <div class="lanyard-bar" aria-hidden="true"><span></span></div>
            <div class="lanyard-window" data-lanyard>
                <ul class="lanyard-track">
                    @foreach ($members as $member)
                        @php
                            $photo = \App\Support\Media::url($member->image);
                            $tone = max(1, min(5, (int) $member->tone));
                            $yaw = $members->count() === 1 ? -14 : (int) round(($loop->index - $mid) * -20);
                            $roll = $loop->even ? 2.2 : -2.2;
                            $links = array_values(array_filter([
                                [$member->link_one_label, $member->link_one_url],
                                [$member->link_two_label, $member->link_two_url],
                            ], fn ($pair) => filled($pair[0]) && filled($pair[1])));
                        @endphp
                        <li class="hang tone-{{ $tone }}" style="--yaw: {{ $yaw }}deg; --roll: {{ $roll }}deg;">
                            <div class="strap" aria-hidden="true"><i></i></div>
                            <article class="badge" data-badge tabindex="0" aria-label="Kartu {{ $member->name }}">
                                <div class="badge-spin">
                                    <div class="badge-front">
                                        <span class="badge-cap" aria-hidden="true"></span>
                                        <div class="badge-people">
                                            <span class="badge-logo">
                                                @if ($mark)
                                                    <img src="{{ $mark }}" alt="">
                                                @else
                                                    <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M7 23h7v-6h7V9" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg>
                                                @endif
                                            </span>
                                            @if ($photo)
                                                <img class="badge-face" src="{{ $photo }}" alt="Foto {{ $member->name }}">
                                            @else
                                                <span class="badge-face fallback" aria-hidden="true">{{ \Illuminate\Support\Str::of($member->name)->substr(0, 1) }}</span>
                                            @endif
                                        </div>
                                        <p class="badge-name">{{ $member->name }}</p>
                                        @if ($member->role)<p class="badge-role">{{ $member->role }}</p>@endif
                                        @if ($member->team)<p class="badge-team">{{ $member->team }}</p>@endif
                                        <span class="barcode" aria-hidden="true"></span>
                                    </div>
                                    <div class="badge-back">
                                        <span class="badge-cap" aria-hidden="true"></span>
                                        <p class="badge-name">{{ $member->name }}</p>
                                        @if ($member->bio)<p>{{ $member->bio }}</p>@endif
                                        @if ($links)
                                            <div class="badge-links">
                                                @foreach ($links as [$label, $href])
                                                    <a href="{{ $href }}" @if(str_starts_with($href, 'http')) target="_blank" rel="noopener noreferrer" @endif>{{ $label }}</a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
