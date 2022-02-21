import { useState, createContext } from 'react';

const AuthContext = createContext({
  auth: null,
  setAuth: (auth) => {},
});

export function AuthProvider({ children }) {
  const [auth, setAuth] = useState({});

  return (
    <AuthContext.Provider value={{ auth, setAuth }}>
      {children}
    </AuthContext.Provider>
  );
}

export default AuthContext;
