import { AnimatePresence } from 'framer-motion';
import { useState } from 'react';
import { CSSTransition } from 'react-transition-group';
import Modal from './Modal';
import ModalChildren from './ModalChildren';

function Navbar() {
  const [modalOpen, setModalOpen] = useState(false);
  const [formProp, setFormProp] = useState('');

  const close = () => {
    setModalOpen(false);
    setFormProp('');
  };
  const open = (param: string) => {
    setModalOpen(true);
    setFormProp(param);
  };

  const [inMan, setInMan] = useState(false);
  const [inBell, setInBell] = useState(false);
  const [search, setSearch] = useState(false);
  const [inHome, setInHome] = useState(false);
  const [inProp, setInProp] = useState(false);

  const toggleInMan = () =>
    setInMan((value) => {
      if (search) {
        setSearch(false);
        return true;
      } else if (!value) {
        setInProp(true);
        return true;
      } else {
        setInProp(false);
        return false;
      }
    });
  const toggleSearch = () =>
    setSearch((value) => {
      if (inMan) {
        setInMan(false);
        return true;
      } else if (!value) {
        setInProp(true);
        return true;
      } else {
        setInProp(false);
        return false;
      }
    });
  const toggleInHome = () =>
    setInHome((value) => {
      setInMan(false);
      setSearch(false);
      setInProp(false);
      return true;
    });
  const toggleInBell = () =>
    setInBell((value) => {
      setInMan(false);
      setSearch(false);
      setInProp(false);
      return true;
    });

  return (
    <>
      <CSSTransition in={inProp} timeout={200} classNames="nav-trans">
        <nav className="navbar">
          <h2>
            <a className="brand" href="#">
              Forum
            </a>
          </h2>
          <div className="wrapper">
            <div className="overflow">
              <CSSTransition in={inMan} timeout={200} classNames="nav-man">
                <ul className="navbar-nav">
                  <li className="nav-item ">
                    <button
                      className="btn hollow"
                      onClick={() => open('Login')}
                    >
                      Login
                    </button>
                  </li>
                  <li className="nav-item ">
                    <button
                      className="btn full "
                      onClick={() => open('Signup')}
                    >
                      Signup
                    </button>
                  </li>
                </ul>
              </CSSTransition>
              <ul className="navbar-menu">
                <li className="menu-item">
                  <button onClick={toggleInHome}>
                    {inHome ? (
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="2rem"
                        height="2rem"
                        fill="currentColor"
                        className="toggled"
                        viewBox="0 0 16 16"
                      >
                        <path
                          fillRule="evenodd"
                          d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6zm5-.793V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"
                        />
                        <path
                          fillRule="evenodd"
                          d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"
                        />
                      </svg>
                    ) : (
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="2rem"
                        height="2rem"
                        fill="currentColor"
                        className="bi bi-house"
                        viewBox="0 0 16 16"
                      >
                        <path
                          fillRule="evenodd"
                          d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z"
                        />
                        <path
                          fillRule="evenodd"
                          d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"
                        />
                      </svg>
                    )}
                  </button>
                </li>

                <li className="menu-item">
                  <button onClick={toggleInBell}>
                    {inBell ? (
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="1.69rem"
                        height="1.69rem"
                        fill="currentColor"
                        className="toggled"
                        viewBox="0 0 16 16"
                      >
                        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zm.995-14.901a1 1 0 1 0-1.99 0A5.002 5.002 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901z" />
                      </svg>
                    ) : (
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="1.69rem"
                        height="1.69rem"
                        fill="currentColor"
                        className="bi bi-bell"
                        viewBox="0 0 16 16"
                      >
                        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
                      </svg>
                    )}
                  </button>
                </li>
                <li className="menu-item">
                  <button onClick={toggleSearch}>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      width="1.69rem"
                      height="1.69rem"
                      fill="currentColor"
                      className={search ? 'toggled' : ''}
                      viewBox="0 0 16 16"
                    >
                      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg>
                  </button>
                </li>
                <li className="menu-item">
                  <button onClick={toggleInMan}>
                    {inMan ? (
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="2rem"
                        height="2rem"
                        fill="currentColor"
                        className="toggled"
                        viewBox="0 0 16 16"
                      >
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                      </svg>
                    ) : (
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="2rem"
                        height="2rem"
                        fill="currentColor"
                        className="bi bi-person"
                        viewBox="0 0 16 16"
                      >
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                      </svg>
                    )}
                  </button>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </CSSTransition>
      <AnimatePresence
        initial={false}
        exitBeforeEnter={true}
        onExitComplete={() => null}
      >
        {modalOpen && (
          <Modal handleClose={close}>
            <ModalChildren content={formProp}></ModalChildren>
          </Modal>
        )}
      </AnimatePresence>
    </>
  );
}

export default Navbar;
