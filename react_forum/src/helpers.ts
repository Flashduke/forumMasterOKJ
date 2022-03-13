export const formatAuthor = (author: string, username: string): string => {
  if (author === username) return 'You';
  return author;
};

export const formatCount = (count: number): string => {
  if (count / 1000000000 > 1)
    return (Math.round((count / 1000000000) * 100) / 100).toString() + 'B';
  if (count / 1000000 > 1)
    return (Math.round((count / 1000000) * 100) / 100).toString() + 'M';
  if (count / 2000 > 1)
    return (Math.round((count / 1000) * 100) / 100).toString() + 'K';
  return count.toString();
};

export const capitalize = (line: string):string => line.charAt(0).toUpperCase() + line.slice(1);