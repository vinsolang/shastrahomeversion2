import Alpine from 'alpinejs';
import 'aos/dist/aos.css';
import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/navigation';

import { registerSiteHeaderState } from './header-state';
import { registerProjectsPortfolioState } from './projects-portfolio';
import {
    activateProjectSwiper,
    initializeProjectSwipers,
    resetProjectSwiper,
} from './project-swipers';
import { initializeScrollAnimations } from './scroll-animations';
import { initializeVideoStartTimes } from './video-start-times';

registerSiteHeaderState();
registerProjectsPortfolioState();
window.activateProjectSwiper = activateProjectSwiper;
window.resetProjectSwiper = resetProjectSwiper;
window.Alpine = Alpine;

Alpine.start();
initializeProjectSwipers();
initializeScrollAnimations();
initializeVideoStartTimes();
