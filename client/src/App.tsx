import React from 'react';
import {ChangeEvent, Dispatch, FormEvent, SetStateAction, useEffect, useRef, useState} from "react";
import './App.css';
import {BrowserRouter, Link, NavLink, redirect, Route, Routes, Navigate} from "react-router-dom";
import Login, {formDataInterface} from "./Routes/Login";
import {IPost} from "./types/Post";
import Deco from "./Routes/Deco"
import Home from "./Routes/Home";
import NeedAuth from "./Routes/NeedAuth";


interface authInterface {
    value: boolean
}


function App() {
    const [auth, setAuth] = useState<authInterface>({value : false})
    const [posts, setPosts] = useState<{ posts: IPost[] }>({posts: []})

    useEffect(() => {
        if (sessionStorage.token) {
            setAuth({value : true})
        }
    },[])

    const deco = () => {
        sessionStorage.removeItem('token');
    }

    return (
        <div className="min-vh-100 gradient-custom">
            <BrowserRouter>
                <Routes>
                    <Route path={"/login"} element={<Login/>}/>
                    <Route path={'/'} element={
                        <NeedAuth>
                            <Home setPosts={setPosts} posts={posts}/>
                        </NeedAuth>
                    }/>
                </Routes>
            </BrowserRouter>
        </div>
    );
}

export default App;
