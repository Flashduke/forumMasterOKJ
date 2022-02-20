import React, {
  Dispatch,
  useState,
  SetStateAction,
  Context,
  createContext,
} from 'react';

type Children = {
  children: React.ReactElement;
};

interface AuthContextProps {
  email: String | null;
  password: String | null;
  role: String | null;
  accessToken: String | null;
}

const AuthContext: Context<{
  auth: AuthContextProps;
  setAuth: Dispatch<SetStateAction<AuthContextProps>>;
}> = createContext(null);

export function AuthProvider({ children }: Children) {
  const [auth, setAuth] = useState({
    email: null,
    password: null,
    role: null,
    accessToken: null,
  });

  return (
    <AuthContext.Provider value={{ auth, setAuth }}>
      {children}
    </AuthContext.Provider>
  );
}

export default AuthContext;
