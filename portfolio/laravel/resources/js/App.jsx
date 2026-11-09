import React, { useCallback, useEffect, useState } from 'react';
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import Home from './Pages/Home';
import { LocaleContext } from './lib/LocaleContext';
import { translate } from './lib/translations';

const SUPPORTED_LOCALES = ['fa', 'en'];
const FALLBACK_LOCALE = 'fa';

function initialLocale() {
    const stored = localStorage.getItem('portfolio-locale');
    const fromDocument = document.documentElement.lang;
    return SUPPORTED_LOCALES.includes(stored) ? stored : (SUPPORTED_LOCALES.includes(fromDocument) ? fromDocument : FALLBACK_LOCALE);
}

export default function App() {
    const [locale, setLocaleState] = useState(initialLocale);

    const currentLocale = useCallback(() => locale, [locale]);
    const isLocale = useCallback((value) => locale === value, [locale]);
    const t = useCallback((key) => translate(locale, key), [locale]);

    const setLocale = useCallback(async (next) => {
        if (!SUPPORTED_LOCALES.includes(next)) return;
        await fetch('/locale', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ locale: next }),
        });
        localStorage.setItem('portfolio-locale', next);
        setLocaleState(next);
    }, []);

    useEffect(() => {
        document.documentElement.lang = locale;
    }, [locale]);

    const contextValue = { locale, currentLocale, isLocale, t, setLocale };

    return (
        <LocaleContext.Provider value={contextValue}>
            <BrowserRouter basename="/">
                <Routes>
                    <Route path="/" element={<Home />} />
                    <Route path="*" element={<Home />} />
                </Routes>
            </BrowserRouter>
        </LocaleContext.Provider>
    );
}
