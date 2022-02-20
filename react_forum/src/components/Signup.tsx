import { useRef, useState, useEffect, RefObject } from 'react';
import { AxiosError } from 'axios';
import axios from '../api/axios';

const NAME_REGEX = /^[A-z][A-z0-9-_]{3,23}$/;
const EMAIL_REGEX =
  /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
const PWD_REGEX = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%]).{8,24}$/;
const SIGNUP_URL = '/user/signup.php';

function Signup() {
  const emailRef = useRef<HTMLInputElement>(null);
  const errRef = useRef<HTMLParagraphElement>(null);

  const [email, setEmail] = useState('');
  const [validEmail, setValidEmail] = useState(false);
  const [emailFocus, setEmailFocus] = useState(false);

  const [name, setName] = useState('');
  const [validName, setValidName] = useState(false);
  const [nameFocus, setNameFocus] = useState(false);

  const [password, setPassword] = useState('');
  const [validPassword, setValidPassword] = useState(false);
  const [passwordFocus, setPasswordFocus] = useState(false);

  const [confirm, setConfirm] = useState('');
  const [validConfirm, setValidConfirm] = useState(false);
  const [confirmFocus, setConfirmFocus] = useState(false);

  const [errMsg, setErrMsg] = useState('');
  const [success, setSuccess] = useState(false);

  useEffect(() => {
    emailRef.current?.focus();
  }, []);

  useEffect(() => {
    const result = NAME_REGEX.test(name);
    console.log(result);
    console.log(name);
    setValidName(result);
  }, [name]);

  useEffect(() => {
    const result = EMAIL_REGEX.test(email);
    setValidEmail(result);
  }, [email]);

  useEffect(() => {
    const result = PWD_REGEX.test(password);
    console.log(result);
    console.log(password);
    setValidPassword(result);
    const match = password === confirm;
    setValidConfirm(match);
  }, [password, confirm]);

  useEffect(() => {
    setErrMsg('');
  }, [name, password, confirm]);

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    const v1 = NAME_REGEX.test(name);
    const v2 = PWD_REGEX.test(password);
    if (!v1 || !v2) {
      setErrMsg('Invalid Entry');
      return;
    }
    try {
      const response = await axios.post(
        SIGNUP_URL,
        JSON.stringify({ email, name, password, confirm }),
        {
          headers: { 'Content-Type': 'application/json' },
          withCredentials: true,
        }
      );
      console.log(response.data);
      setSuccess(true);
    } catch (err: any) {
      if (!err?.response) setErrMsg('No Server Response');
      else if (err.response?.status === 409) setErrMsg('Username Taken');
      else setErrMsg('Signup Failed');

      errRef.current?.focus();
    }
  };

  return (
    <>
      {success ? (
        <>
          <h1>Success!</h1>
          <p>
            <a href="#">Login</a>
          </p>
        </>
      ) : (
        <>
          <p
            ref={errRef}
            className={errMsg ? 'errmsg' : 'offscreen'}
            aria-live="assertive"
          >
            {errMsg}
          </p>
          <h1>Signup</h1>
          <form onSubmit={handleSubmit}>
            <label
              htmlFor="email"
              className={!email ? '' : !validEmail ? 'invalid' : 'valid'}
            >
              Email
              <span className={validEmail ? 'valid' : 'hide'}></span>
              <span
                className={validEmail || !email ? 'hide' : 'invalid'}
              ></span>
            </label>
            <input
              type="email"
              name="email"
              ref={emailRef}
              autoComplete="off"
              onChange={(e) => setEmail(e.target.value)}
              required
              aria-invalid={validEmail ? 'false' : 'true'}
              aria-describedby="emailnote"
              onFocus={() => setEmailFocus(true)}
              onBlur={() => setEmailFocus(false)}
              className={
                !email ? 'form-control' : !validEmail ? 'danger' : 'success'
              }
            />
            <p
              id="emailnote"
              className={
                emailFocus && email && !validEmail
                  ? 'instructions'
                  : 'offscreen'
              }
            >
              Please enter a valid email address
            </p>

            <label
              htmlFor="name"
              className={!name ? '' : !validName ? 'invalid' : 'valid'}
            >
              Username
              <span className={validName ? 'valid' : 'hide'}></span>
              <span className={validName || !email ? 'hide' : 'invalid'}></span>
            </label>
            <input
              type="text"
              name="name"
              autoComplete="off"
              onChange={(e) => setName(e.target.value)}
              required
              aria-invalid={validName ? 'false' : 'true'}
              aria-describedby="uidnote"
              onFocus={() => setNameFocus(true)}
              onBlur={() => setNameFocus(false)}
              className={
                !name ? 'form-control' : !validName ? 'danger' : 'success'
              }
            />
            <p
              id="uidnote"
              className={
                nameFocus && name && !validName ? 'instructions' : 'offscreen'
              }
            >
              4 to 24 characters.
              <br />
              Must begin with a letter.
              <br />
              Letters, numbers, underscores, hyphens allowed.
            </p>

            <label
              htmlFor="password"
              className={!password ? '' : !validPassword ? 'invalid' : 'valid'}
            >
              Password
              <span className={validPassword ? 'valid' : 'hide'}></span>
              <span
                className={validPassword || !email ? 'hide' : 'invalid'}
              ></span>
            </label>
            <input
              type="password"
              name="password"
              onChange={(e) => setPassword(e.target.value)}
              required
              aria-invalid={validPassword ? 'false' : 'true'}
              aria-describedby="pwdnote"
              onFocus={() => setPasswordFocus(true)}
              onBlur={() => setPasswordFocus(false)}
              className={
                !password
                  ? 'form-control'
                  : !validPassword
                  ? 'danger'
                  : 'success'
              }
            />
            <p
              id="pwdnote"
              className={
                passwordFocus && !validPassword ? 'instructions' : 'offscreen'
              }
            >
              8 to 24 characters.
              <br />
              Must include uppercase and lowercase letters, a number and a
              special character.
              <br />
              Allowed special characters:{' '}
              <span aria-label="exclamation mark">!</span>{' '}
              <span aria-label="at symbol">@</span>{' '}
              <span aria-label="hashtag">#</span>{' '}
              <span aria-label="dollar sign">$</span>{' '}
              <span aria-label="percent">%</span>
            </p>

            <label
              htmlFor="confirm"
              className={!confirm ? '' : !validConfirm ? 'invalid' : 'valid'}
            >
              Password again
              <span
                className={validConfirm && confirm ? 'valid' : 'hide'}
              ></span>
              <span
                className={validConfirm || !confirm ? 'hide' : 'invalid'}
              ></span>
            </label>
            <input
              type="password"
              name="confirm"
              onChange={(e) => setConfirm(e.target.value)}
              required
              aria-invalid={validConfirm ? 'false' : 'true'}
              aria-describedby="confirmnote"
              onFocus={() => setConfirmFocus(true)}
              onBlur={() => setConfirmFocus(false)}
              className={
                !confirm ? 'form-control' : !validConfirm ? 'danger' : 'success'
              }
            />
            <p
              id="confirmnote"
              className={
                confirmFocus && !validConfirm ? 'instructions' : 'offscreen'
              }
            >
              Must match the first password input field.
            </p>

            <button
              disabled={
                !validEmail || !validName || !validPassword || !validConfirm
                  ? true
                  : false
              }
              className="btn hollow"
            >
              Signup
            </button>
          </form>

          <p>
            Already signed up?
            <br />
            <span className="line">
              <a href="#">Login Here</a>
            </span>
          </p>
        </>
      )}
    </>
  );
}

export default Signup;
