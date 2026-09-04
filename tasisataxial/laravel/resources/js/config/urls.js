const apiUrl = import.meta.env.VITE_API_URL || "/api";
const storageUrl = import.meta.env.VITE_STORAGE_URL || "/storage";

export function apiUrlPath(path) {
    return `${apiUrl}/${path}`.replace(/([^:]\/)\/+/g, "$1");
}

export function storageUrlPath(path) {
    return `${storageUrl}/${path}`.replace(/([^:]\/)\/+/g, "$1");
}

export async function apiFetch(path, options = {}) {
    const response = await fetch(apiUrlPath(path), options);

    if (!response.ok) {
        throw new Error(`API request failed: ${response.status}`);
    }

    return response.json();
}