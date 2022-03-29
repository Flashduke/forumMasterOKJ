import React, { useEffect, useState } from 'react';
import axios from '../api/axios';
import useAxiosPrivate from '../hooks/useAxiosPrivate';
import { communitiesData, defaultCommunitiesData } from '../models/Community';

type Props =
  | { type?: 'post'; postID?: never; cID?: string }
  | { type: 'comment'; postID: string; cID?: never };

function CreateContent({ type, postID, cID }: Props) {
  const axiosPrivate = useAxiosPrivate();
  const controller = new AbortController();

  const [allCommunities, setAllCommunities] = useState<communitiesData>(
    defaultCommunitiesData
  );
  const [communityID, setCommunityID] = useState('');
  const [content, setContent] = useState('');
  const [title, setTitle] = useState('');

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    try {
      const response = await axiosPrivate.post(
        `/${type}/create.php`,
        JSON.stringify({ postID, communityID, content, title }),
        { signal: controller.signal }
      );
      console.log(response.data);
    } catch (err) {
      console.error(err);
    }
  };

  const getAllCommunities = async () => {
    try {
      const response = await axios.get('/community/read.php', {
        withCredentials: true,
      });
      const data = response?.data?.data;
      setAllCommunities({ isLoaded: true, data });
    } catch (err) {
      console.error(err);
    }
  };
  useEffect(() => {
    if (cID) setCommunityID(cID);
    else getAllCommunities();
  }, []);

  return (
    <form onSubmit={handleSubmit}>
      {type === 'post' && (
        <>
          {!cID && (
            <select
              className="form-control"
              name="select_community"
              onChange={(e) => setCommunityID(e.target.value)}
              required
            >
              <option disabled selected value="">
                Select Community...
              </option>
              {allCommunities.isLoaded &&
                allCommunities?.data?.map((community, index) => (
                  <option key={index} value={community.id}>
                    {community.name}
                  </option>
                ))}
            </select>
          )}
          <input
            className="form-control"
            type="text"
            name="title"
            placeholder="Title"
            onChange={(e) => setTitle(e.target.value)}
            required
          />
        </>
      )}
      <textarea
        className="form-control"
        name="text"
        rows={10}
        placeholder="Text"
        onChange={(e) => setContent(e.target.value)}
        required
      ></textarea>
      <button className="btn hollow" type="submit">
        {type === 'post' ? 'Post' : 'Comment'}
      </button>
    </form>
  );
}

export default CreateContent;
