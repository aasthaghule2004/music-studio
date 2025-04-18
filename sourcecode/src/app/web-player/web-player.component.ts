import {Component, ElementRef, OnDestroy, OnInit, Renderer2, ViewChild, ViewEncapsulation} from '@angular/core';
import {SearchSlideoutPanel} from './search/search-slideout-panel/search-slideout-panel.service';
import {Player} from './player/player.service';
import {WebPlayerState} from './web-player-state.service';
import {FullscreenOverlay} from './fullscreen-overlay/fullscreen-overlay.service';
import {Settings} from 'common/core/config/settings.service';
import {WebPlayerImagesService} from './web-player-images.service';
import {OverlayContainer} from '@angular/cdk/overlay';
import {NavigationEnd, Router} from '@angular/router';
import {filter} from 'rxjs/operators';

@Component({
    selector: 'web-player',
    templateUrl: './web-player.component.html',
    styleUrls: ['./web-player.component.scss'],
    encapsulation: ViewEncapsulation.None,
    host: {'id': 'web-player'}
})
export class WebPlayerComponent implements OnInit, OnDestroy {
    @ViewChild('scrollContainer') scrollContainer: ElementRef<HTMLElement>;

    public shouldHideVideo = false;
    constructor(
        public searchPanel: SearchSlideoutPanel,
        public player: Player,
        private renderer: Renderer2,
        public state: WebPlayerState,
        private overlay: FullscreenOverlay,
        private settings: Settings,
        private wpImages: WebPlayerImagesService,
        private overlayContainer: OverlayContainer,
        private router: Router,
    ) {}

    ngOnInit() {
        this.player.init();
        this.overlay.init();
        this.shouldHideVideo = this.settings.get('player.hide_video');
        this.overlayContainer.getContainerElement().classList.add('web-player-theme');
        this.resetScrollTop();
    }

    ngOnDestroy() {
        this.player.destroy();
        this.overlay.destroy();
        this.overlayContainer.getContainerElement().classList.remove('web-player-theme');
    }

    private resetScrollTop() {
        this.router.events
            .pipe(filter(e => e instanceof NavigationEnd))
            .subscribe(() => {
                this.scrollContainer.nativeElement.scrollTop = 0;
            });
    }
}
