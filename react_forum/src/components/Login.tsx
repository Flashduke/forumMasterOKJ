import { useRef, useState, useEffect } from 'react';
import { useLocation, useNavigate } from 'react-router-dom';
import axios from '../api/axios';
import useAuth from '../hooks/useAuth';

type Prop = {
  handleClose: () => void;
};

type LocationState = {
  from?: Location;
};

const LOGIN_URL = '/user/login.php';

function Login({ handleClose }: Prop) {
  const { setAuth } = useAuth();

  const navigate = useNavigate();
  const location = useLocation();
  const state = location.state as LocationState;
  const from = state?.from?.pathname || '/';

  const emailRef = useRef<HTMLInputElement>(null);
  const errRef = useRef<HTMLParagraphElement>(null);

  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [errMsg, setErrMsg] = useState('');

  useEffect(() => {
    emailRef.current?.focus();
  }, []);

  useEffect(() => {
    setErrMsg('');
  }, [email, password]);

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    try {
      const response = await axios.post(
        LOGIN_URL,
        JSON.stringify({ email, password }),
        {
          headers: { 'Content-Type': 'application/json' },
          withCredentials: true,
        }
      );

      const accessToken = response?.data?.accessToken;
      const role = response?.data?.role;
      const name = response?.data?.name;

      handleClose();

      setAuth({
        email,
        name,
        password,
        role,
        accessToken,
      });
      
      setTimeout(() => {
        setAuth({});
      }, 24 * 60 * 60 * 1000);

      setEmail('');
      setPassword('');

      navigate(from, { replace: true });
    } catch (err: any) {
      if (!err?.response) setErrMsg('No Server Response');
      else if (err?.response?.status === 400)
        setErrMsg('Wrong Email or Password');
      else if (err?.response?.status === 401) setErrMsg('Unauthorized');
      else setErrMsg('Login Failed');
      errRef.current?.focus();
    }
  };

  return (
    <>
      <p
        ref={errRef}
        className={errMsg ? 'errmsg' : 'offscreen'}
        aria-live="assertive"
      >
        {errMsg}
      </p>
      <h1>Login</h1>
      <form onSubmit={handleSubmit}>
        <label htmlFor="email">Email</label>
        <input
          type="email"
          name="email"
          ref={emailRef}
          autoComplete="off"
          onChange={(e) => setEmail(e.target.value)}
          value={email}
          required
          className="form-control"
        />
        <label htmlFor="password">Password</label>
        <input
          type="password"
          name="password"
          onChange={(e) => setPassword(e.target.value)}
          value={password}
          required
          className="form-control"
        />
        <button disabled={!email || !password} className="btn hollow">
          Login
        </button>
      </form>
    </>
  );
}
export default Login;
