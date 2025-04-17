import {Injectable} from '@angular/core';
import {Resolve, RouterStateSnapshot, ActivatedRouteSnapshot, Router} from '@angular/router';
import {Genres} from '../genres.service';
import {Genre} from '../../../models/Genre';
import {WebPlayerState} from '../../web-player-state.service';
import {catchError, mergeMap} from 'rxjs/operators';
import {EMPTY, of} from 'rxjs';
import {BackendResponse} from '../../../../common/core/types/backend-response';

@Injectable()
export class PopularGenresResolver implements Resolve<BackendResponse<{genres: Genre[]}>> {

    constructor(
        private genres: Genres,
        private router: Router,
        private state: WebPlayerState,
    ) {}

    resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): BackendResponse<{genres: Genre[]}> {
        this.state.loading = true;
        return this.genres.getPopular().pipe(
            catchError(() => {
                this.state.loading = false;
                this.router.navigate(['/']);
                return EMPTY;
            }),
            mergeMap(response => {
                this.state.loading = false;

                if (response.genres) {
                    return of(response);
                } else {
                    this.router.navigate(['/']);
                    return EMPTY;
                }
            })
        );
    }
}
