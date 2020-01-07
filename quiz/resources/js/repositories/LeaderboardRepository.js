import Repository from 'axios';

const resource = '/leaderboard';

export default {
    get() {
        return Repository.get(`${resource}/`);
    },
}