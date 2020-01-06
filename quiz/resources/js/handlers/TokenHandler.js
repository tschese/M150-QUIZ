const storageKey = "token";

export const TokenHandler = {
    storeToken(token) {
        window.localStorage.setItem(storageKey, token);
    },

    getToken() {
        return window.localStorage.getItem(storageKey);
    },

    removeToken() {
        window.localStorage.removeItem(storageKey);
    }
}
