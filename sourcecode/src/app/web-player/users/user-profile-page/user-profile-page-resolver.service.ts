import {Injectable} from '@angular/core';
import {Router, Resolve, RouterStateSnapshot, ActivatedRouteSnapshot} from '@angular/router';
import {WebPlayerState} from '../../web-player-state.service';
import {User} from 'common/core/types/models/User';
import {Users} from 'common/auth/users.service';
import {catchError, mergeMap} from 'rxjs/operators';
import {EMPTY, of} from 'rxjs';
import {BackendResponse} from '../../../../common/core/types/backend-response';

@Injectable()
export class UserProfilePageResolver implements Resolve<BackendResponse<{user: User}>> {
    constructor(
        private users: Users,
        private router: Router,
        private state: WebPlayerState
    ) {}

    resolve(route: ActivatedRouteSnapshot, state: RouterStateSnapshot): BackendResponse<{user: User}> {
        this.state.loading = true;
        const id = +route.paramMap.get('id');

        return this.users.get(id, {with: 'playlists,followers,followedUsers'}).pipe(
            catchError(() => {
                this.state.loading = false;
                this.router.navigate(['/']);
                return EMPTY;
            }),
            mergeMap(response => {
                this.state.loading = false;
                if (response.user) {
                    return of(response);
                } else {
                    this.router.navigate(['/']);
                    return EMPTY;
                }
            })
        );
    }
}
