import { capitalize } from '../helpers';

type Props = {
  type: string;
  name?: string;
  peopleCount?: number;
  description?: string;
  createdAt?: Date;
  handleOpen?: () => void;
};

function PageAbout({
  type,
  peopleCount,
  createdAt,
  description,
  name,
  handleOpen,
}: Props) {
  const createdAtDate = new Date(createdAt);
  const createdAtString = createdAtDate.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
  return (
    <div className="aside-about">
      <h1>
        {type !== 'home' && 'About '}
        {capitalize(name ? name : type)}
      </h1>
      {description && <span>{description}</span>}
      {type !== 'home' && (
        <>
          <span>
            {type === 'profile' ? 'Followers: ' : 'Members: '}
            {peopleCount}
          </span>
          <span>
            <time dateTime={'datetime'}>
              Created on {createdAt && createdAtString}
            </time>
          </span>
        </>
      )}
      {type !== 'profile' && (
        <button className="btn full" onClick={handleOpen}>
          Create Post
        </button>
      )}
      {type === 'home' && (
        <button className="btn hollow" disabled>Create Community</button>
      )}
    </div>
  );
}

export default PageAbout;
