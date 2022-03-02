import { useNavigate, useParams } from "react-router-dom";

type Props = {}

const Profile = (props: Props) => {
    const params = useParams();
    const navigate = useNavigate();
    
  return (
    <div className="content">{params.profile} Profile</div>
  )
}

export default Profile