import { useState, createContext } from 'react';

const RatingContext = createContext({
  rating: null,
  setRated: (rating) => {},
});

export function RatingProvider({ children }) {
  const [rating, setRated] = useState({});

  return (
    <RatingContext.Provider value={{ rating, setRated }}>
      {children}
    </RatingContext.Provider>
  );
}

export default RatingContext;
