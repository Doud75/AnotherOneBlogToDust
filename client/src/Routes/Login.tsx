import {ChangeEvent, Dispatch, FormEvent, SetStateAction, useEffect, useRef, useState} from "react";
import {btoa} from "buffer";
import {inspect, isError} from "util";
import {useLocation, useNavigate} from "react-router-dom";

export interface formDataInterface {
    username: string,
    password: string
}

export interface Ierror {
    isError: boolean,
    message: string
}

export default function Form() {

    const [formData, setFormData] = useState<formDataInterface>({password: "", username: ""})
    const navigate = useNavigate()
    const [error, setError] = useState<Ierror>({isError: false, message: ""})

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        fetch('http://localhost:5657/login', {
            method: "POST",
            mode: "cors",
            body: new URLSearchParams({
                ...formData
            }),
            credentials: "include",
            headers: new Headers({
                "Authorization" : "Basic amZnbWFpbC5jb206cGFzc3dvcmQ=",
                "Content-type":  "application/x-www-form-urlencoded"
            })
        })
            .then(data => data.json())
            .then(json => {
                if (json.token) {
                    sessionStorage.setItem('token', JSON.stringify(json))
                    navigate("/")
                }
                setError({...error, isError: true, message: json.error})
            })
    }

    const handleChange = (e: ChangeEvent) => {
        setFormData(prevState => {
            return {
                ...prevState,
                // @ts-ignore
                [e.target.name]: e.target.value
            }
        })
    }

    return (
            <section className="min-vh-100 gradient-custom">
                <div className="container py-5 h-100">
                    <div className="row d-flex justify-content-center align-items-center h-100">
                        <div className="col-12 col-md-8 col-lg-6 col-xl-5">
                            <div className="card bg-dark text-white" style={{borderRadius: '1rem'}}>
                                <div className="card-body p-5 text-center">

                                    <form className="mb-md-5 mt-md-4 pb-5" onSubmit={handleSubmit}>

                                        <h2 className="fw-bold mb-2 text-uppercase">Login</h2>
                                        <p className="text-white-50 mb-5">Please enter your login and password!</p>

                                        <div className="form-outline form-white mb-4">
                                            <input type="text" id="typeEmailX" className="form-control form-control-lg" name="username" onChange={handleChange}/>
                                            <label className="form-label" htmlFor="typeEmailX">Email</label>
                                        </div>

                                        <div className="form-outline form-white mb-4">
                                            <input type="password" id="typePasswordX" className="form-control form-control-lg" name="password" onChange={handleChange}/>
                                            <label className="form-label" htmlFor="typePasswordX">Password</label>
                                        </div>

                                        <button className="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                                        <br/>
                                        <br/>
                                        {error.isError && <h4 className='error'>{error.message}</h4>}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    )
}
