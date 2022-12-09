import {Dispatch, SetStateAction} from "react";

export interface FormPost {
    title: string,
    content: string
}

export interface IPost extends FormPost {
    id: number,
    author: string,
    createdAt: object,
    userId: number
}

interface IShowProps {
    setPosts: Dispatch<SetStateAction<{ posts: IPost[] }>>
    posts: { posts: IPost[] }
}