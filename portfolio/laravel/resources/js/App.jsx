import React from 'react';
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import Home from './Pages/Home';

export default function App() {
    return (
        <BrowserRouter basename="/">
            <Routes>
                <Route path="/" element={<Home />} />
                <Route path="*" element={<Home />} />
            </Routes>
        </BrowserRouter>
    );
}
