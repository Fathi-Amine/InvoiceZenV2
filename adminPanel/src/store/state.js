const store = {
    user: {
        token: sessionStorage.getItem('TOKEN'),
        data: {

        }
    },
    products: {
        loading: false,
        data: [],
        links: [],
        from: null,
        to: null,
        page: 1,
        limit: null,
        total: null
    },
    sections: {
        data: [],
    },
    invoices:{
        loading: false,
        data:[],
        links: [],
        from: null,
        to: null,
        page: 1,
        limit: null,
        total: null
    }
}

export default store