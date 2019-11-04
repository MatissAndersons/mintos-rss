import {authHeader} from "../helpers/auth-header";

export const userService = {
    login,
    logout,
    register,
    getFeed,
    checkEmail
};

function login(email, password) {
    const requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
    };

    return fetch(`${process.env.MIX_API_URL}/login`, requestOptions)
        .then(handleResponse)
        .then(user => {
            if (user.token) {
                localStorage.setItem('user', JSON.stringify(user));
            }

            return user;
        });
}

function logout() {
    localStorage.removeItem('user');
}

function register(user) {
    const requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(user)
    };

    return fetch(`${process.env.MIX_API_URL}/register`, requestOptions).then(handleResponse);
}

function checkEmail(email) {
    const requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({email})
    };

    return fetch(`${process.env.MIX_API_URL}/check-email`, requestOptions).then(handleResponse);
}

function getFeed() {
    const requestOptions = {
        method: 'POST',
        headers: authHeader()
    };

    return fetch(`${process.env.MIX_API_URL}/feed`, requestOptions).then(handleResponse);
}

function handleResponse(response) {
    return response.text().then(text => {
        const data = text && JSON.parse(text);
        if (!response.ok) {
            if (response.status === 401) {
                // auto logout if 401 response returned from api
                logout();
                location.reload();
            }

            const error = (data && data.message) || response.statusText;
            return Promise.reject(error);
        }

        return data;
    });
}
