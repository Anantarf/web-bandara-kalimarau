<!-- Scroll Animation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Handle fade-up animation
                        if (entry.target.classList.contains('scroll-animate')) {
                            entry.target.classList.add('opacity-100', 'translate-y-0');
                            entry.target.classList.remove('opacity-0', 'translate-y-8');
                        }

                        // Handle counter animation
                        if (entry.target.classList.contains('stat-counter')) {
                            const target = parseInt(entry.target.getAttribute('data-target'), 10);
                            if (target > 0) {
                                const duration = 2000; // 2 seconds
                                const start = performance.now();
                                const step = (timestamp) => {
                                    // Use easeOutExpo logic for smoother slowdown at the end
                                    let progress = (timestamp - start) / duration;
                                    if (progress > 1) progress = 1;
                                    const easeProgress = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
                                    
                                    const currentVal = Math.floor(easeProgress * target);
                                    entry.target.innerText = new Intl.NumberFormat('id-ID').format(currentVal);
                                    
                                    if (progress < 1) {
                                        window.requestAnimationFrame(step);
                                    } else {
                                        entry.target.innerText = new Intl.NumberFormat('id-ID').format(target);
                                    }
                                };
                                window.requestAnimationFrame(step);
                            } else {
                                entry.target.innerText = "0";
                            }
                        }

                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });

            document.querySelectorAll('.scroll-animate, .stat-counter').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
