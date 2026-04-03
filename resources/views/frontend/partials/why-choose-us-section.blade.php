@php
    $difference = $difference ?? [];
    $variant = $variant ?? 'services';
@endphp

{{-- Difference --}}
<section class="overflow-hidden bg-white">
    <div class="mx-auto max-w-[1904px]">
        <div
            class="relative mx-auto min-h-[42rem] w-full bg-white md:h-[36rem] md:min-h-[36rem] xl:h-[692px] xl:min-h-[692px]">
            <div class="absolute inset-0 overflow-hidden md:inset-x-0 md:top-0 md:bottom-0 xl:top-0 xl:right-50 xl:left-0 xl:h-[637px]"
                data-aos="fade-right">
                <img src="{{ asset('assets/images/Services/Services-img.png') }}" alt=""
                    class="absolute inset-0 h-full w-full origin-center object-cover object-[34%_44%] scale-[1.08] md:scale-[1.05] xl:scale-[1.12] xl:object-[38%_42%]"
                    loading="lazy" decoding="async">
            </div>

            @if ($variant === 'about')
                <div class="absolute right-4 bottom-0 left-4 z-10 md:right-6 md:left-6 xl:right-[clamp(1.5rem,3.25vw,3.5rem)] xl:left-[clamp(1.5rem,18vw,16rem)] 2xl:left-[clamp(1.5rem,34vw,36.75rem)]"
                    data-aos="fade-left" data-aos-delay="120">
                    <div
                        class="bg-[rgba(8,8,8,0.9)] px-[1.2rem] pt-6 pb-8 text-white shadow-[0_28px_60px_rgba(0,0,0,0.28)] backdrop-blur-[1.5px] md:px-6 md:pt-8 md:pb-10 xl:px-[clamp(1.5rem,3.5vw,4rem)] xl:pt-[clamp(2rem,4.5vw,4rem)] xl:pb-[clamp(2.5rem,5vw,5rem)]">
                        <p class="text-[clamp(0.9rem,0.95vw,1.1rem)] font-normal tracking-[0.42em] text-[#ff9500]">
                            {{ $difference['eyebrow'] ?? '' }}
                        </p>

                        <h2
                            class="mt-8 font-display text-[clamp(2.6rem,3.65vw,4.25rem)] leading-[0.98] font-light tracking-[-0.04em] text-white">
                            {{ $difference['title'] ?? '' }}
                        </h2>

                        <div
                            class="mt-9 grid max-w-[54rem] gap-6 text-[clamp(0.95rem,1.08vw,1.18rem)] leading-[1.32] font-light text-white/[0.9]">
                            @foreach ($difference['paragraphs'] ?? [] as $paragraph)
                               <p>{!! $paragraph !!}</p>
                            @endforeach
                        </div>
                    </div>

                    <div class="h-[1.15rem] bg-[#FF8800] md:h-[1.6rem] xl:h-[55px]" aria-hidden="true"></div>
                </div>
            @else
                <div class="absolute inset-0 z-10" data-aos="fade-left" data-aos-delay="120">
                    <div
                        class="absolute right-4 bottom-4 left-4 bg-[rgba(8,8,8,0.9)] px-[1.2rem] pt-6 pb-8 text-white shadow-[0_28px_60px_rgba(0,0,0,0.28)] backdrop-blur-[1.5px] md:right-6 md:bottom-9 md:left-6 md:px-6 md:pt-8 md:pb-10 xl:right-[clamp(1.5rem,3.25vw,3.5rem)] xl:bottom-[8px] xl:left-[clamp(1.5rem,18vw,16rem)] xl:px-[clamp(1.5rem,3.5vw,4rem)] xl:pt-[clamp(2rem,4.5vw,4rem)] xl:pb-[clamp(2.5rem,5vw,5rem)] 2xl:left-[clamp(1.5rem,34vw,36.75rem)]">
                        <p class="text-[clamp(0.9rem,0.95vw,1.1rem)] font-normal tracking-[0.42em] text-[#ff9500]">
                            {{ $difference['eyebrow'] ?? '' }}
                        </p>

                        <h2
                            class="mt-8 font-display text-2xl lg:text-[clamp(2.6rem,3.65vw,4.25rem)] leading-[0.98] font-light tracking-[-0.04em] text-white">
                            {{ $difference['title'] ?? '' }}
                        </h2>

                        <div
                            class="mt-9 grid max-w-[54rem] gap-6 text-[clamp(0.95rem,1.08vw,1.18rem)] leading-[1.32] font-light text-white/[0.9]">
                            @foreach ($difference['paragraphs'] ?? [] as $paragraph)
                                <p>{!! $paragraph !!}</p>
                            @endforeach
                        </div>
                    </div>

                    <div class="absolute right-4 bottom-0 left-4 h-[1.15rem] bg-[#FF8800] md:right-6 md:left-6 md:h-[1.6rem] xl:top-[637px] xl:right-[clamp(1.5rem,3.25vw,3.5rem)] xl:left-[clamp(1.5rem,18vw,16rem)] xl:h-[55px] 2xl:left-[clamp(1.5rem,34vw,36.75rem)]"
                        aria-hidden="true"></div>
                </div>
            @endif
        </div>
    </div>
</section>
