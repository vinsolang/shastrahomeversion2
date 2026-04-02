@php
    $media = $media ?? [];
    $sectionId = $sectionId ?? null;
    $sectionClass = $sectionClass ?? 'overflow-hidden bg-white pb-[clamp(4rem,7vw,6rem)]';
    $stageClass = $stageClass ?? 'relative h-[22rem] min-h-[22rem] w-full overflow-hidden bg-[#101010] md:h-[24rem] md:min-h-[24rem] md:w-full xl:ml-[-21px] xl:h-[470px] xl:min-h-[470px] xl:w-[min(1925px,calc(100%+21px))]';
    $mediaVideos = collect($media['videos'] ?? [])
        ->map(function ($video): array {
            if (is_string($video)) {
                return ['src' => $video];
            }

            if (is_array($video)) {
                return [
                    'src' => $video['src'] ?? $video['video'] ?? null,
                ];
            }

            return ['src' => null];
        })
        ->filter(static fn (array $video): bool => filled($video['src'] ?? null))
        ->values();

    if ($mediaVideos->isEmpty() && filled($media['video'] ?? null)) {
        $mediaVideos = collect([['src' => $media['video']]]);
    }

   $mediaVideoSources = $mediaVideos
    ->map(function ($video) {

        $src = $video['src'] ?? null;

        if (!$src) return null;

        return filter_var($src, FILTER_VALIDATE_URL)
            ? $src
            : asset($src);
    })
    ->filter()
    ->values()
    ->all();
    $hasMultipleMediaVideos = count($mediaVideoSources) > 1;
@endphp

{{-- Media --}}
<section @if (filled($sectionId)) id="{{ $sectionId }}" @endif class="{{ $sectionClass }}">
    <div class="mx-auto max-w-[1904px]">
        <div
            class="{{ $stageClass }}"
            data-aos="fade-up"
            x-data="{
                activeVideo: 0,
                videos: @js($mediaVideoSources),
                playActive() {
                    const video = this.$refs.mediaVideo;

                    if (! video || ! this.videos.length) {
                        return;
                    }

                    video.load();

                    const playPromise = video.play();

                    if (playPromise !== undefined) {
                        playPromise.catch(() => {});
                    }
                },
                previous() {
                    if (this.videos.length < 2) {
                        return;
                    }

                    this.activeVideo = (this.activeVideo - 1 + this.videos.length) % this.videos.length;
                    this.$nextTick(() => this.playActive());
                },
                next() {
                    if (this.videos.length < 2) {
                        return;
                    }

                    this.activeVideo = (this.activeVideo + 1) % this.videos.length;
                    this.$nextTick(() => this.playActive());
                },
            }"
            x-init="playActive()"
        >
            <video
                x-ref="mediaVideo"
                class="absolute inset-0 h-full w-full object-cover"
                x-bind:src="videos.length ? videos[activeVideo] : ''"
                x-bind:key="activeVideo"
                autoplay
                muted
                loop
                playsinline
                preload="metadata"
            ></video>

            <div
                class="absolute inset-0 bg-[linear-gradient(90deg,rgba(10,10,10,0.72)_0%,rgba(10,10,10,0.5)_42%,rgba(10,10,10,0.58)_100%)]"
                aria-hidden="true"
            ></div>

            <div class="relative z-10 flex h-full items-center px-4 py-[clamp(1.5rem,4vw,3rem)] text-white md:px-[2.5rem]">
                {{-- Controls --}}
                @if ($hasMultipleMediaVideos)
                    <button
                        type="button"
                        class="absolute top-1/2 left-3 -translate-y-1/2 text-[2.2rem] leading-none font-[200] text-white/70 transition hover:text-white md:left-[clamp(1rem,1.5vw,1.8rem)] md:text-[clamp(2.5rem,3.2vw,3.4rem)]"
                        @click="previous()"
                        aria-label="Show previous media video"
                    >
                        &#8249;
                    </button>
                @endif

                {{-- Copy --}}
                <div class="max-w-[15rem] md:max-w-[34rem] md:pl-[4.5rem] lg:max-w-[32rem] xl:max-w-[37rem] xl:pl-[clamp(3rem,7vw,8rem)]" :class="{ 'pl-[3.15rem]': videos.length > 1, 'pl-[0.6rem]': videos.length < 2 }" data-aos="fade-right" data-aos-delay="120">
                    <p class="font-display text-[clamp(1.2rem,2vw,2.8rem)] leading-[1.12] italic font-normal text-white lg:text-[2.45rem] lg:leading-[1.08] xl:text-[2.8rem]">
                        <span class="whitespace-nowrap">{{ $media['headline_prefix'] ?? '' }}<span class="font-editorial italic">{{ ' ' . ($media['headline_emphasis'] ?? '') }}</span></span>
                        <span class="mt-1 block whitespace-nowrap md:mt-0">{{ $media['headline_suffix'] ?? '' }}<span class="text-[#ff9100]">{{ $media['accent'] ?? '' }}</span></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
