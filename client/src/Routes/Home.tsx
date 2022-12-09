import {IShowProps} from "../types/Post";
import FormPost from "../Component/FormPost";
import ShowPost from "../Component/ShowPost";
import {useLocation, useNavigate} from "react-router-dom";
import React from "react";

export default function Home({setPosts, posts}: IShowProps) {

    const navigate = useNavigate()

    const deco = () => {
        sessionStorage.removeItem('token');
        navigate("/login");
    }

    return(
        <>
            <button className="btn btn-outline-light btn-lg px-5" onClick={deco}>Logout</button>
            <FormPost setPosts={setPosts} posts={posts}/>
            <ShowPost setPosts={setPosts} posts={posts}/>
        </>
    )
}