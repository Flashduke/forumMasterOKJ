import { useContext } from 'react';
import RatingContext from '../context/RatingProvider';

function useRating() {
  return useContext(RatingContext);
}

export default useRating;
