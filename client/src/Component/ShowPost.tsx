import {ChangeEvent, Dispatch, FormEvent, SetStateAction, useEffect, useRef, useState} from "react";
import {IPost, IShowProps} from "../types/Post";
import {useLocation, useNavigate} from "react-router-dom";
import Post from "./Post";


export default function ShowPost({setPosts, posts}: IShowProps) {

    // @ts-ignore
    const token = JSON.parse(sessionStorage.token)
    const navigate = useNavigate()

    useEffect(() => {
        fetch('http://localhost:5657/', {
            headers: new Headers({
                "Authorization" : "Bearer " + token.token,
            })
        })
            .then(data => data.json())
            .then(json => {
                if (json.message) {
                    if (json.message === "invalid cred") {
                        sessionStorage.removeItem('token');
                        navigate("/login")
                    }
                    return
                }
                setPosts(json)
            })

    },[])

    console.log(posts)

    return (
        <>

            {posts.posts.map((value, index) => {
                return (<Post key={index} {...value}/>)
            })}
        </>
    )
}