import { useDispatch, useSelect } from "@wordpress/data"
import { store as noticeStore } from "@wordpress/notices"
import { NoticeList } from "@wordpress/components"

export const Notices = () => {
	const { removeNotice } = useDispatch( noticeStore )
	const notices = useSelect( ( select ) =>
		select( noticeStore ).getNotices()
	)

	if( notices.length === 0 ){
		return null
	}

	return <NoticeList notices={ notices } onRemove={ removeNotice } />
}
