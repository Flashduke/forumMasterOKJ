export interface IPost {
  author: string;
  communityName: string;
  comments: string;
  content: string;
  createdAt: Date;
  thumbsDowns: number;
  thumbsUps: number;
  id: string;
  title: string;
}

export interface postData {
  isLoaded: boolean;
  posts: IPost[];
}

export const defaultPostData: postData = {
  isLoaded: false,
  posts: [],
};
