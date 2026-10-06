<div class="preloader">
    <div class="preloader__balls">
        <span class="preloader__ball"></span>
        <span class="preloader__ball"></span>
        <span class="preloader__ball"></span>
        <span class="preloader__ball"></span>
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
            <defs>
                <filter id="ball">
                    <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
                    <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="ball" />
                    <feBlend in="SourceGraphic" in2="ball" />
                </filter>
            </defs>
        </svg>
    </div>
</div>