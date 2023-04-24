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
    users: {
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
    },
    invoiceProducts:{
        data: []
    },
    invoiceCustomers:{
        data: []
    },
    notification:{
        show: false,
        message: ""
    }
}

export default store