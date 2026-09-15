const revealItems = document.querySelectorAll(".reveal");

const observer = new IntersectionObserver(
    (entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = "running";
                observer.unobserve(entry.target);
            }
        });
    },
    { threshold: 0.12 },
);

revealItems.forEach((item) => {
    item.style.animationPlayState = "paused";
    observer.observe(item);
});
