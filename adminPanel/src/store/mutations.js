export function setUser(state, user) {
    console.log(user);
    console.log(state);
    state.user.data = user;
}

export function setToken(state, token) {
    console.log(token)
    state.user.token = token;
    if (token) {
        sessionStorage.setItem('TOKEN', token)
    } else {
        sessionStorage.removeItem('TOKEN');
    }
}