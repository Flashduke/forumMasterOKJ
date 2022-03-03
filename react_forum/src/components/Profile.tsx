import { useNavigate, useParams } from "react-router-dom";
import Feed from "./Feed";

type Props = {}

const Profile = (props: Props) => {
    const params = useParams();
    const navigate = useNavigate();
    
  return (
    <div className="content">{params.profile} Profile
    <Feed profile={params.profile} onProfilePage={true} /></div>
  )
}

export default Profile