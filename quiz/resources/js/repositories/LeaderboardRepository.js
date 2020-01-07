import Repository from 'axios';

const resource = '/leaderboard';

export default {
    get() {
        return Repository.get(`${resource}/`);
    },

    submitScore(points, userId) {
        let data = { 'points': points, 'userId': userId };
        return Repository.post(`${resource}/addScore`, data);
    }
}