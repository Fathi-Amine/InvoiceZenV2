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

export function setProducts(state, [loading, response = null]) {
    if (response) {
        console.log(response);
        state.products = {
            data: response.data,
            links: response.meta.links,
            total: response.meta.total,
            limit: response.meta.per_page,
            from: response.meta.from,
            to: response.meta.to,
            page: response.meta.current_page,
        }
    }
    state.products.loading = loading;
}

export function setSections(state, sections) {
    console.log(sections)
    state.sections.data = sections;
}