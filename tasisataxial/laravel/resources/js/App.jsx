import React from 'react';
import { BrowserRouter, Route, Routes } from 'react-router-dom';
import Home from "./Pages/Home";
import Categories from './Pages/categories';
import About from './Pages/About';
import Product from './Pages/Product';
import Services from './Pages/Services';
import CardPage from './Pages/CartPage';
import Projects from './Pages/projects';
import Article from './Pages/Article';
import { CartContextProvider } from './components/store/CartContext';

const root = document.getElementById('app')
const data= JSON.parse(root.getAttribute('data-page'));
export default function App(){
    return(
       <BrowserRouter basename='/'>
            <CartContextProvider>
                <Routes>
                    <Route path='/' element={<Home/>}/>
                    <Route path='/home' element={<Home/>}/>
                    <Route path='cats/:maincat/:cat?' element={<Categories/>}/>
                    <Route path='about' element={<About/>}/>
                    <Route path='product/:id' element={<Product/>}/>
                    <Route path='services' element={<Services/>}/>
                    <Route path='projects/:id' element={<Projects/>}/>
                    <Route path='article/:id' element={<Article/>}/>
                    <Route path='cart' element={<CardPage/>}/>
                </Routes>
            </CartContextProvider>
       </BrowserRouter>
    )
}