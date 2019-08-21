import Dashboard from '../components/Dashboard';
import Profile from '../components/Profile';
import User from '../components/User';
import Developer from '../components/Developer';
import Billhistory from '../components/Billhistory';
import Mill from '../components/Mill';
import UserAccount from '../components/UserAccount';
import Report from '../components/Report';
// Report
export const routes = [
    { path: '/dashboard', component: Dashboard },
    { path: '/profile', component: Profile },
    { path: '/users', component: User },
    { path: '/developer', component: Developer },
    { path: '/bill-history', component: Billhistory },
    { path: '/mill-account', component: Mill },
    { path: '/user-accounts', component: UserAccount },
    { path: '/report', component: Report },
  ]