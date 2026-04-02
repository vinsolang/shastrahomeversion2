<button id="scroll-top-btn"
    class="fixed bottom-4 right-4 bg-[#830B00] hidden z-[300] w-12 h-12 items-center justify-center rounded-full text-white transition-all duration-300 ease-in-out animate-bounce shadow-lg"
    onclick="scrollToTop()" aria-label="Scroll to Top">
    <i class="fa-solid fa-arrow-up-long"></i>
</button>

<script>
    window.addEventListener("scroll", function() {
        const scrollBtn = document.getElementById("scroll-top-btn");
        if (window.scrollY > 200) {
            scrollBtn.classList.remove("hidden");
        } else {
            scrollBtn.classList.add("hidden");
        }
    });

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    }
</script>
