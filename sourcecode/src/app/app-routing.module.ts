import {NgModule} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';
import {ContactComponent} from '../common/contact/contact.component';

const routes: Routes = [
    {path: 'admin', loadChildren: 'app/admin/app-admin.module#AppAdminModule'},
    {path: 'contact', component: ContactComponent},
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule]
})
export class AppRoutingModule {
}
