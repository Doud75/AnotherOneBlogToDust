import React from "react";
import {Navigate} from "react-router-dom";

export interface INeedAuthProps {
    children: JSX.Element
}

export default function NeedAuth(props: INeedAuthProps) {
    if (sessionStorage.token) {
        return props.children
    } else {
        return <Navigate to={"/login"}/>
    }
}
