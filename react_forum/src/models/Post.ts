export interface IPost {
  author?: string;
  communityName?: string;
  commentCount: number;
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
export interface singlePostData {
  isLoaded: boolean;
  post: IPost;
}
export const defaultPostData: postData = {
  isLoaded: false,
  posts: [],
};
export const defaultSinglePostData: singlePostData = {
  isLoaded: false,
  post: {
    commentCount: 0,
    content: '',
    createdAt: null,
    thumbsDowns: 0,
    thumbsUps: 0,
    id: '',
    title: '',
  },
};
