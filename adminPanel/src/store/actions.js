import axiosClient from '../axios';

export function getUser({ commit }) {
    return axiosClient.get('/user').then(({ data }) => {
        commit('setUser', data)
        return data
    })
}

export function login({ commit }, data) {

    return axiosClient.post('/login', data).then(({ data }) => {
        commit('setUser', data.user);
        commit('setToken', data.token);
        return data;
    })
}

export function logout({ commit }) {
    return axiosClient.post('/logout')
        .then((response) => {
            commit('setToken', null);
            return response;
        })
}


export function getProducts({ commit }, { url = null, search = "", perPage = 5, sort_field, sort_direction } = {}) {
    commit('setProducts', [true])
    url = url || '/product'
    return axiosClient.get(url, {
        params: {
            search,
            per_page: perPage,
            sort_field,
            sort_direction
        }
    })
        .then(response => {
            commit('setProducts', [false, response.data])
        }).catch(() => {
            commit('setProducts', [false])
        })
}

export function getSections({ commit }) {
    return axiosClient.get('/sections')
        .then(response => {
            commit('setSections', response.data)
        })
}

export function getProduct({ }, id) {
    return axiosClient.get(`/product/${id}`)
}

export function createProduct({ commit }, product) {
    return axiosClient.post('/product', product)
}

export function updateProduct({ commit }, product) {
    const id = product.id;
    product._method = 'PUT';
    return axiosClient.post(`/product/${id}`, product)
}

export function deleteProduct({ commit }, id) {
    return axiosClient.delete(`/product/${id}`)
}


export function getInvoices({commit},{url=null,search = "", perPage = 5}){
    commit('setInvoices', [true])
    url = url || '/invoice'
    return axiosClient.get(url,{
        params: {
            search,
            per_page : perPage

        }
    })
    .then(res => {
        commit('setInvoices', [false, res.data])
    })
    .catch(() => {
        commit('setInvoices', [false]);
    })
}