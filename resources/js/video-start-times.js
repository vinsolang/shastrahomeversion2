export const initializeVideoStartTimes = () => {
    document.querySelectorAll('video[data-start-time]').forEach((video) => {
        const startTime = Number(video.dataset.startTime ?? 0);

        if (! Number.isFinite(startTime) || startTime <= 0) {
            return;
        }

        // Seek once when the browser is ready
        const seekToStart = () => {
            if (video.dataset.seeked === 'true') {
                return;
            }

            try {
                video.currentTime = startTime;
                video.dataset.seeked = 'true';
            } catch (error) {
                // Ignore early seek blocks
            }
        };

        video.addEventListener('loadedmetadata', seekToStart, { once: true });
        video.addEventListener('canplay', seekToStart, { once: true });

        if (video.readyState >= 1) {
            seekToStart();
        }
    });
};
